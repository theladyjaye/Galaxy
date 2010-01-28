//
//  GalaxyApplication.h
//  GalaxyClientCore
//
//  Created by Adam Venturella on 1/24/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "GalaxyCacheDelegate.h"
#import "GalaxyOperationDelegate.h"
#import "GalaxyCacheDelegate.h"

@class GalaxyCommand, GalaxyOptions;
@interface GalaxyApplication : NSObject <GalaxyOperationDelegate>
{
	NSOperationQueue * networkOperations;
	GalaxyOptions * defaultOptions;
	id<GalaxyCacheDelegate> cacheDelegate;
}

@property(nonatomic, assign) id<GalaxyCacheDelegate> cacheDelegate;

@property(nonatomic, readonly)GalaxyOptions * defaultOptions;
- (void)channels:(SEL)callback;
- (void)execute:(GalaxyCommand *)command options:(GalaxyOptions *) options;
- (void)setApplicationId:(NSString *)value;
- (void)setApplicationKey:(NSString *)value;
- (void)setApplicationSecret:(NSString *)value;

@end
