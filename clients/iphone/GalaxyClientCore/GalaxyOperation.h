//
//  GalaxyOperation.h
//  GalaxyClientCore
//
//  Created by Adam Venturella on 1/25/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "GalaxyOperationDelegate.h"

@class GalaxyCommand, GalaxyOptions;
@interface GalaxyOperation : NSOperation 
{
	NSData * result;
	GalaxyCommand * command;
	GalaxyOptions * options;
	NSObject <GalaxyOperationDelegate> * delegate;
}
@property(nonatomic, readonly) NSData * result;
@property(nonatomic, assign) NSObject <GalaxyOperationDelegate> * delegate;
@property(nonatomic, retain) GalaxyCommand * command;
@property(nonatomic, retain) GalaxyOptions * options;

- (GalaxyOperation *)initWithCommandAndOptions:(GalaxyCommand *)consumer_command options:(GalaxyOptions *)consumer_options;
@end
