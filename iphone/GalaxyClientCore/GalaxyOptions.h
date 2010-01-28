//
//  GalaxyOptions.h
//  GalaxyClientCore
//
//  Created by Adam Venturella on 1/25/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "GalaxyAuthorization.h"

@interface GalaxyOptions : NSObject <NSCopying>{
	NSString * applicationFormat;
	NSString * context;
	GalaxyAuthorization * authorization;
}

@property(nonatomic, retain) NSString * applicationFormat;
@property(nonatomic, retain) NSString * context;
@property(nonatomic, retain) GalaxyAuthorization * authorization;

@end
